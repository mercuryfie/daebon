<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('/web/include/meta_View'); ?>
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
    <!--###############-->
</head>
<body>
<?= $this->include('/web/include/header_View'); ?>
<?= $this->include('/web/include/global_View'); ?>

<main>
    <section class="merregister greenmain" >
        <div class="merwrap">
            <div class="merleft">
                <?= $this->include('/web/include/left_View'); ?>
            </div>

            <div class="merright">
                <?= $this->renderSection('content'); ?>
                <?= $this->include('/web/include/grayFoot_View'); ?>
            </div>
        </div>
    </section>
</main>

<?php //= $this->include('/web/include/grayFoot_View'); ?>
</body>
</html>

