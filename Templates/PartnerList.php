<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Arts Corps - Program Partners</title>
    </head>
    <body>
        <div id="partner-list">
            <h1>Arts Corps Program Partners</h1>
            <div class="error-message"><?php print $view['errors']?></div>
            <?php if(! $view['errors']) { ?>
            <!-- <?php print $view['dump'] ?> -->
            <ul id="partners-by-neighborhood">
                <?php
                foreach($view['byNeighborhood'] as $neighborhood => $data) {
                ?>
                <li class="<?php print $neighborhood ?>">
                <h3><?php print $neighborhood ?></h3>
                    <ul class="partner-record">
                    <?php foreach($data as $partner) { ?>
                        <li><?php print $partner['partnerLink'] ?>
                            <?php if ($partner['classList']) { ?>
                            <ul class="class-list">
                                <?php foreach($partner['classList'] as $classLink) { ?>
                                    <li><?php print $classLink ?></li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                    </ul>
                <?php } ?>
                </li>
            </ul>
            <?php } ?>
        </div>
    </body>
</html>