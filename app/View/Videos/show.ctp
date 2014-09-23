<h1><?php echo h($video['Video']['title']); ?></h1>

<p><small>Created: <?php echo $video['Video']['created']; ?></small></p>
<p><?php echo $this->Html->link('FLV', $video['Video']['FLV'] ); ?></p>
<p><?php
  if ($video['Video']['MP4']) {
    echo $this->Html->link('MP4', $video['Video']['MP4'] );
  }
  else {
    echo('MP4 is not ready yet');
  } ?></p>
<p><?php echo $this->Form->postLink('Delete video', array( 'action' => 'delete', $video['Video']['id']), 
                                    array( 'method' => 'delete') )?></p>