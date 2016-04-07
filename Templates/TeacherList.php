<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Arts Corps - Teachers</title>
    </head>
    <body>
        <h1>Arts Corps Teaching Artists</h1>
        <div class="error-message"><?php print $view['errors']?></div>
        <?php if(! $view['errors']) { ?>
        <ul id="teacher-list">
            <?php
            foreach($view['byMedium'] as $medium => $data) {
            ?>
            <li class="<?php print $medium ?>">
            <h3><?php print $medium ?></h3>
                <?php
                foreach($data as $teacher) {
                ?>
                    <dl class="teacher-summary">
                        <dt class="teacher-link">
                            <?php print $teacher['thumbnail'] ?>
                            <?php print $teacher['teacherLink'] ?>
                        </dt>
                        <dd class="teacher-medium"><?php print $teacher['medium'] ?></dd>
                        <dd class="teacher-bio"><?php print $teacher['bio']?></dd>
                    </dl>
                <?php
                }
                ?>

            <?php
            }
            ?>
        </ul>

        </div>
        <p class="annotation">
        These courses are still in the planning stage.  If you don't see what you are looking for,
        please check back again.
        </p>
        <?php } ?>
    </body>
</html>