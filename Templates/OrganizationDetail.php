<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Arts Corps - <?php print $view['name']?> Organization Detail</title>
    </head>
    <body>
        <div class="error-message"><?php print $view['errors']?></div>
        <?php if(! $view['errors']) { ?>
        <div id="organization-profile">
            <!-- <?php print $view['dump']?> -->
            <h1><?php print $view['name']?></h1>
            <?php print $view['description'] ?>
            <?php print $view['address']?>
            <?php print $view['phone']?>
            <?php print $view['website']?>
            <?php print $view['mapLink']?>
            <?php if ($view['current'] or $view['next']) { ?>
                 <?php if ($view['current']) { ?>
                <h2><?php print $view['currentName'] ?></h2>
                <table class="class-list">
                    <tr><th>Course Name</th><th>Teacher</th></tr>
                    <?php foreach($view['current'] as $class) { ?>
                        <tr>
                            <td><?php print $class['classLink'] ?></td>
                            <td><?php print $class['teacherLink'] ?></td>
                            <td><?php print $class['registerLink'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <?php } ?>
                <?php if ($view['next']) { ?>
                <h2><?php print $view['nextName'] ?></h2>
                <table class="class-list">
                    <tr><th>Course Name</th><th>Teacher</th></tr>
                    <?php foreach($view['next'] as $class) { ?>
                        <tr>
                            <td><?php print $class['classLink'] ?></td>
                            <td><?php print $class['teacherLink'] ?></td>
                            <td><?php print $class['registerLink'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <?php } ?>
                <!--TODO: Not actually sure about this condition, but it seems that in some
                    circumstances we don't want to allude to classes at all. -->
            <?php } elseif ($view['isFacility'] and !$view['isPartner']) { ?>
            <p class="message">Not currently any classes at this facility.</p>
            <?php } ?>
        </div>
        <?php } ?>
    </body>
</html>