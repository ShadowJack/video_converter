<h1><strong><?php echo h($video['Video']['title']); ?></strong></h1>

<p><small>Created: <?php echo $video['Video']['created']; ?></small></p>
<p>Download: <?php echo $this->Html->link('FLV', $video['Video']['FLV'] ); ?></p>
<p>Download: <?php
  if ($video['Video']['MP4']) {
    echo $this->Html->link('MP4', $video['Video']['MP4'] );
  }
  else {
    echo('MP4 is not ready yet');
  } ?></p>
<p>Dimensions: <?php echo $video['Video']['dimensions']?></p>
<p>Video bitrate: <?php echo $video['Video']['bv']?></p>
<p>Audio bitrate: <?php echo $video['Video']['ba']?></p>
<p><?php echo $this->Form->postLink('Delete video', array( 'action' => 'delete', $video['Video']['id']), 
                                    array( 'method' => 'delete') )?></p>