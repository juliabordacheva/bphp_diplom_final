<?php

if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
    $tasksList = new Task($user->status);
    $filter_param = isset($_GET['filter']) ? "&filter=" . $_GET['filter'] : "";


    ?>


    <div class="menu_wrapper">
        <div class="menu_container">
            <div class="<?= (preg_match('/\/$/', $_SERVER['REQUEST_URI']) == 1 ||
                preg_match('/\/index\.php$/', $_SERVER['REQUEST_URI']) == 1) ?
                'menu_item' : 'menu_item' ?>">
                <a href="index.php">Все задания</a>
            </div>
            <div class="<?= (preg_match('/filter=new/', $_SERVER['REQUEST_URI']) == 1) ?
                'menu_item menu_item_active' : 'menu_item' ?>">
                <a href="index.php?filter=new">Новые</a>
            </div>
            <div class="<?= (preg_match('/filter=resolved/', $_SERVER['REQUEST_URI']) == 1) ?
                'menu_item menu_item_active' : 'menu_item' ?>">
                <a href="index.php?filter=resolved">На проверке</a>
            </div>
            <div class="<?= (preg_match('/filter=rejected/', $_SERVER['REQUEST_URI']) == 1) ?
                'menu_item menu_item_active' : 'menu_item' ?>">
                <a href="index.php?filter=rejected"">На доработке</a>
            </div>
            <div class="<?= (preg_match('/filter=done/', $_SERVER['REQUEST_URI']) == 1) ?
                'menu_item menu_item_active' : 'menu_item' ?>">
                <a href="index.php?filter=done">Готовые</a>
            </div>
            <?php if ($user->status == 'admin') { ?>
                <div class="menu_item"><a href="index.php?new=true">Создать новое</a></div>
            <?php } ?>
            <div class="menu_item"><a href="logout.php">Выход</a></div>
        </div>
    </div>

    <h1>Добро пожаловать, <?= $user->status;?> <?=$user->name;?></h1>
    <p></p>
    <div class="content">
        <?php
        if (isset($_GET['new'])) {
            include 'new_task_form.php';
        } elseif (isset($_GET['create'])) {
            include 'create_new_task.php';
        } elseif (isset($_GET['edit'])) {
            $task = $tasksList->getTask($_GET['edit']);
            include 'edit_task.php';
        } elseif (isset($_GET['save'])) {
            $task = $tasksList->getTask($_GET['save']);
            include 'save_task.php';
        } elseif (isset($_GET['translate'])) {
            $task = $tasksList->getTask($_GET['translate']);
            include 'translate.php';
        } elseif (isset($_GET['save_translate'])) {
            $task = $tasksList->getTask($_GET['save_translate']);
            include 'save_translate.php';
        } elseif (isset($_GET['resolve_translate'])) {
            $task = $tasksList->getTask($_GET['resolve_translate']);
            include 'resolve_translate.php';
        } elseif (isset($_GET['check'])) {
            $task = $tasksList->getTask($_GET['check']);
            include 'check_task.php';
        } elseif (isset($_GET['done_task'])) {
            $task = $tasksList->getTask($_GET['done_task']);
            include 'done_task.php';
        } elseif (isset($_GET['delete'])) {
            $task = $tasksList->getTask($_GET['delete']);
            include 'delete_task.php';
        } else {
            $tasks = $tasksList->getList();
            if (isset($_GET['filter'])) $tasks = $tasksList->getFilteredList($_GET['filter']);
            if (count($tasks) == 0) echo '<p class="message">Заданий не найдено</p>';

            foreach ($tasks as $value) { ?>
                <?php if ($user->status == 'translator') echo '<a class="task-wrap-link" href="index.php?translate=' . $value['id'] . '">'; ?>
                <div class="container">
                    <div class="old_form_wrapper">
                        <div class="deadline_data"><strong><?= date('d.m.Y', strtotime($value['deadline'])); ?></strong>
                        </div>
                        <div class="lang_task">
                            <?php
                            foreach ($value['trans_lang'] as $lang) {
                                echo "<strong>" . strtoupper($lang) . "</strong>" . "\n";
                            }
                            ?>
                        </div>
                        <div class="task-text"><?= $value['original_text_preview'] ?>...</div>
                        <div class="task-footer">
                            <?php if ($user->status == 'admin') { ?>
                                <div class="task-buttons">
                                    <?php if ($value['status'] == 'resolved')
                                        echo '<a class="task-button" href="index.php?check=' . $value['id'] . '">Проверить</a>'; ?>
                                    <a class="task-button task-button_edit"
                                       href="index.php?edit=<?= $value['id'] ?><?= $filter_param; ?>">Редактировать</a>
                                    <a class="task-button task-button_delete"
                                       href="index.php?delete=<?= $value['id'] ?><?= $filter_param; ?>">Удалить</a>
                                </div>
                            <?php } ?>
                            <div class="task-status">Статус: <strong><?= $value['status']; ?></strong></div>
                        </div>
                    </div>
                </div>
                <?php if ($user->status == 'translator') echo '</a>'; ?>
            <?php }
        } ?>
    </div>
    <?php
}


?>


