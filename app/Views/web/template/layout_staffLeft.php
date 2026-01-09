<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('/web/include/meta_View',$meta); ?>
    <!-- icon fontawesome ----------------------------  -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <!--CSS section-->
    <link rel="stylesheet" href="/assets/web/css/style.css?rnd=<?echo(rand()); ?>">
    <link rel="stylesheet" href="/assets/web/css/style_staff.css?rnd=<?echo(rand()); ?>">
    <!--###############-->
    <!--JS section-->
    <?= $this->include('/web/include/script_View'); ?>
    <!-- font1 ----------------------------  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Electrolize&
    family=Playwrite+AU+QLD:wght@100..400&
    family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&
    family=Kanit:wght@100;200;300;400;500;600;700;800;900&
    family=Noto+Sans:wght@100;200;300;400;500;600;700;800;900&
    family=Noto+Sans+KR:wght@100;300;400;500;700;900&
    family=Birthstone&
    family=Gmarket+Sans:wght@300;500;700&display=swap" rel="stylesheet">
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
    <style>

        main {
            background-color: red;
        }

    </style>
</head>

<body>
<?= $this->include('/web/include/headerStaff_View',$header); ?>
<?= $this->include('/web/include/global_View',$header); ?>

<main>
    <div class="mainWrapStaff">
        <div class="leftWrapStaff">
            <?= $this->include('/web/include/leftStaff_View',$left); ?>
<!--            --><?php //= $this->include('/web/include/leftStaff_View',$leftStaff); ?>
<!--            <p>hello</p>-->
        </div>
        <div class="rightWrapStaff">
            <?= $this->renderSection('content'); ?>
        </div>

    </div>
    <!--    <div class="workpageWrap flexType4">-->
<!--        <div class="leftWrap ">-->
<!--            --><?php //= $this->include('/web/include/left_View',$left); ?>
<!--        </div>-->

<!--        <div class="rightWrap">-->

<!--            --><?php //= $this->include('/web/include/foot_View',$footer); ?>
<!--            --><?php //= $this->include('/web/include/grayFoot_View',$footer); ?>
<!--        </div>-->
<!--    </div>-->
</main>
<?php //= $this->include('/web/include/grayFoot_View',$footer); ?>
<?php //= $this->include('/web/include/foot_View',$footer); ?>

</body>
</html>

