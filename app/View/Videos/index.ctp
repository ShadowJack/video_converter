<h1>All videos</h1>
<?php echo $this->Html->link(
    'Upload video',
    array('controller' => 'videos', 'action' => 'create')
); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>FLV</th>
        <th>MP4</th>
        <th>Created</th>
    </tr>

    <!-- Here is where we loop through our $posts array, printing out post info -->

    <?php foreach ($videos as $video): ?>
    <tr>
        <td><?php echo $video['Video']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($video['Video']['title'],
array('controller' => 'videos', 'action' => 'show', $video['Video']['id'])); ?>
        </td>
        <td><?php echo $video['Video']['FLV']; ?></td>
        <td><?php echo $video['Video']['MP4']; ?></td>
        <td><?php echo $video['Video']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($video); ?>
</table>