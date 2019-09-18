<html>

Enter a city that a wegmans is located in, using all caps.  For example, try "CHERRY HILL" or "DULLES".  The starting address is the University at Buffalo.
<?= $this->Form->create(null, [
    'url' => ['controller' => 'Drivers', 'action' => 'findstore']
]); ?>

<?= $this->Form->control('quote'); ?>

<?= $this->Form->end(); ?>

</html>
