<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Arts Corps - <?php print $view['fullName']?> Teaching Artist Detail</title>
    </head>
    <body>
        <div class="error-message"><?php print $view['errors']?></div>
        <?php if(! $view['errors']) { ?>
        <div id="teacher-profile">
            <!-- <?php print $view['dump']?> -->
            <h1><?php print $view['fullName']?></h1>
            <?php print $view['photo'] ?>
            <p class="teacher-bio"><?php print $view['bio'] ?></p>
            <?php if ($view['courses']) { ?>
            <table id="class-list">
                <thead>
                    <tr><th>Course Name</th><th>Facility</th></tr>
                </thead>
                <tbody>
                    <?php foreach($view['courses'] as $course) { ?>
                        <tr>
                            <td><?php print $course['classLink']?></td>
                            <td><?php print $course['facilityLink']?></td>
                            <td class="register"><?php print $course['registerLink']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else { ?>
            <p class="message">Not currently teaching any classes</p>
            <?php } ?>
        </div>
        <?php } ?>
    </body>
</html>