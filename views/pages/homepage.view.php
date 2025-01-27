<?php
$layoutFile = 'layouts.main';
?>

<div class="col-sm-12">
    <?php if (authUser()): ?>
        <div class="m-5">
            <h1>Hello, <?= authUser()->name; ?></h1>

            <form action="/logout" method="POST"><?= csrfField() ?><input type="submit" class="btn btn-danger" value="Logout"></form>
        </div>
    <?php endif; ?>

    <h2>TITLE HEADING</h2>
    <h5>Title description, Dec 7, 2020</h5>
    <div class="fakeimg">Fake Image</div>
    <p>Some text..</p>
    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>

    <h2 class="mt-5">TITLE HEADING</h2>
    <h5>Title description, Sep 2, 2020</h5>
    <div class="fakeimg">Fake Image</div>
    <p>Some text..</p>
    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
</div>