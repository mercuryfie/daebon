<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('/web/include/meta_View',$meta); ?>
    <!-- font1 ----------------------------  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+KR:wght@100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Birthstone&display=swap" rel="stylesheet">
    <!-- icon fontawesome ----------------------------  -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <!--CSS section-->
    <link rel="stylesheet" href="/assets/web/css/style.css?rnd=<?echo(rand()); ?>">
    <!--###############-->
    <!--JS section-->
    <?= $this->include('/web/include/script_View'); ?>
    <!-- font1 ----------------------------  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+KR:wght@100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Birthstone&display=swap" rel="stylesheet">
    <!-- icon fontawesome ----------------------------  -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>
    <!-- calendar ----------------------------  -->
<!--    <link href="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.css" rel="stylesheet">-->
<!--    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>-->
    <!--###############-->
</head>
<body>
<?= $this->include('/web/include/header_View',$header); ?>
<?= $this->include('/web/include/global_View',$header); ?>

<main>
    <div class="workpageWrap flexType4">
        <div class="leftWrap ">
            <?= $this->include('/web/include/left_View',$left); ?>
        </div>

        <div class="rightWrap">
            <?= $this->renderSection('content'); ?>
<!--            --><?php //= $this->include('/web/include/foot_View',$footer); ?>
            <?= $this->include('/web/include/grayFoot_View',$footer); ?>
        </div>
    </div>
</main>
<?php //= $this->include('/web/include/grayFoot_View',$footer); ?>
<?php //= $this->include('/web/include/foot_View',$footer); ?>

</body>
</html>

