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
          $this->VideoEncoder->convert_video($path, $out_path, 480, 360, true);
          //$this->VideoEncoder->set_buffering($out_path);
          
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