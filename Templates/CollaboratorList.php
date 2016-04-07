<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Arts Corps - Collaborators</title>
    </head>
    <body>
        <h1>Arts Corps Collaborators</h1>
        <div class="error-message"><?php print $view['errors']?></div>
        <?php if(! $view['errors']) { ?>
        <ul id="collaborators">
            <?php foreach($view['collaborators'] as $collaborator) { ?>
                <li><?php print $collaborator['collaboratorLink'] ?></li>
            <?php } ?>
        </ul>
        <?php } ?>
    </body>
</html>