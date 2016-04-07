<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Arts Corps - Professional Development Courses</title>
    </head>
    <body>
        <h1>Arts Corps Professional Development Courses</h1>
        <div class="error-message"><?php print $view['errors']?></div>
        <?php if(! $view['errors']) { ?>
        <div id="pd-class-list">
            <?php
            foreach($view['pd-classes'] as $grouping => $data) {
            ?>
                <h3><?php print $grouping ?> </h3>
                <table class="<?php print $grouping ?>">
                   <tr><th>Course Name</th><th>Teacher</th><th>Location</th></tr>
                       <?php
                       foreach($data as $class) {
                       ?>
                           <tr>
                               <td><?php print $class['classLink'] ?></td>
                               <td><?php print $class['teacherLink'] ?></td>
                               <td><?php print $class['facilityLink'] ?></td>
                               <td><?php print $class['registerLink'] ?></td>
                           </tr>
                       <?php
                       }
                       ?>
                </table>
            <?php
            }
            ?>
        </div>
        <?php } ?>
    </body>
</html>