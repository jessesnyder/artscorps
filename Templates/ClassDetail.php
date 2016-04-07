<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Arts Corps - <?php print $view['name']?> Class Detail</title>
    </head>
    <body>
        <div class="error-message"><?php print $view['errors']?></div>
        <?php if(! $view['errors']) { ?>
        <div id="class-profile">
            <h1><?php print $view['name']?></h1>
            <p class="description"><?php print $view['description'] ?></p>
            <dl class="class-profile">
                <dt>Teaching Artist</dt><dd><?php print $view['teacherLink']?></dd>
                <?php if ($view['co-teacherLink']) { ?>
                    <dt>Co-teacher</dt><dd><?php print $view['co-teacherLink']?></dd>
                <?php } ?>
                <dt>Location</dt><dd><?php print $view['facilityLink']?></dd>
                <dt>Start Date</dt><dd><?php print $view['dateStart']?></dd>
                <dt>End Date</dt><dd><?php print $view['dateEnd']?></dd>
                <?php if ($view['noClassDays']) { ?>
                    <dt>No Class</dt><dd><?php print $view['noClassDays']?></dd>
                <?php } ?>
                <dt>Days</dt><dd><?php print $view['days']?></dd>
                <dt>Time</dt><dd><?php print $view['time']?></dd>
                <dt>Ages</dt><dd><?php print $view['ages']?></dd>
                <dt>Max Students</dt><dd><?php print $view['capacity']?></dd>
                <?php print $view['registerLink']?>
                <p class="epilogue"><?php print $view['epilogue']?></p>
            </dl>
            <!-- <?php print $view['preview']?> -->
        </div>
        <?php } ?>
    </body>
</html>