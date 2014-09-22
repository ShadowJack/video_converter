<h1>Add Video</h1>
<?php
echo $this->Form->create('Video', array('type' => 'file'));
echo $this->Form->input('title');
echo $this->Form->input('FLV_file', array('type' => 'file'));
echo $this->Form->end('Save Post');
?>