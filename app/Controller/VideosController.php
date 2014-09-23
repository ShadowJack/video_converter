<?php 

class VideosController extends AppController {
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'VideoEncoder');
    
    public function index() {
      $this->set('videos', $this->Video->find('all'));
    }
    
    public function show($id = null) {
      if (!$id) {
        throw new NotFoundException(__('Invalid video'));
      }

      $video = $this->Video->findById($id);
      if (!$video) {
        throw new NotFoundException(__('Invalid video'));
      }
      $this->set('video', $video);
    }
    
    public function create() {
      if ($this->request->is('post')) {
        $this->Video->create();
        if ($this->Video->save($this->request->data)) {
          //$path = $this->request->data['Video']['FLV_file']['tmp_name'];
          $path = WWW_ROOT."videos/".($this->Video->id).".flv";
          $out_path = WWW_ROOT."videos/".($this->Video->id).".mp4";
          
          $ffprobe = FFMpeg\FFProbe::create(array('ffprobe.binaries' => '/usr/local/Cellar/ffmpeg/2.3.3/bin/ffprobe'));
          //CakeLog::debug(print_r($ffprobe->streams($path)->videos()->first()->keys(), true));
          $video_data = $ffprobe->streams($path)->videos()->first();
          $width = $video_data->get('width');
          $height = $video_data->get('height');
          $this->Video->set(array('dimensions' => $width."x".$height));
          $video_bit_rate = $video_data->get('bit_rate');
          $this->Video->set(array('bv' => $video_bit_rate));
          CakeLog::debug(print_r($video_bit_rate, true));
          $audio_data = $ffprobe->streams($path)->audios()->first();
          $audio_bit_rate = $audio_data->get('bit_rate');
          $this->Video->set(array('ba' => $audio_bit_rate));
          //CakeLog::debug(print_r($audio_data, true));
          $ffmpeg = FFMpeg\FFMpeg::create(array(
              'ffmpeg.binaries' => '/usr/local/Cellar/ffmpeg/2.3.3/bin/ffmpeg', //TODO: in production add binaries to PATH
              'ffprobe.binaries' => '/usr/local/Cellar/ffmpeg/2.3.3/bin/ffprobe',
              'timeout'          => 3600, // The timeout for the underlying process
              'ffmpeg.threads'   => 5  // The number of threads that FFMpeg should use
          ));
          $video = $ffmpeg->open($path);
          $format = new FFMpeg\Format\Video\X264();
          $format->on('progress', function ($video, $format, $percentage) {
              echo "$percentage % transcoded";
          });

          $format
              -> setKiloBitrate($video_bit_rate/1000)
              -> setAudioChannels(2)
              -> setAudioKiloBitrate($audio_bit_rate/1000);
          
          $video
              ->save($format, $out_path);
          // save info about converted video into db
          $this->Video->set(array('MP4' => "/videos/".($this->Video->id).".mp4"));
          $this->Video->save();
          
          $this->Session->setFlash(__('Your video has been saved.'));
          return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Unable to add your video.'));
      }
    }
    
    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if ($this->Video->delete($id)) {
            $this->Session->setFlash(
                __('The video with id: %s has been deleted.', h($id))
            );
            return $this->redirect(array('action' => 'index'));
        }
    }
}