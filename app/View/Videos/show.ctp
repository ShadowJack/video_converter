<h1><?php echo h($video['Video']['title']); ?></h1>

<p><small>Created: <?php echo $video['Video']['created']; ?></small></p>
<p>FLV: <?php echo $video['Video']['FLV']; ?></p>
<p>MP4: <?php echo $video['Video']['MP4']; ?></p>
<p><?php echo $this->Form->postLink('Delete video', array( 'action' => 'delete', $video['Video']['id']), 
                                    array( 'method' => 'delete') )?></p>