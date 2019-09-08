<?php
$jsonFileAccessModel = new JsonFileAccessModel($task['id'], $task['ref_lang']);
$filter_param = isset($_GET['filter']) ? "?filter=" . $_GET['filter'] : "";
?>
<div class="container">
    <div class="row">
        <div class="form_wrapper">

            <div class="button_close"><a href="index.php<?= $filter_param; ?>">Закрыть</a></div>

            <form action="index.php?save=<?= $task['id']; ?>" method="POST">
                <div class="form_wrapper_1">
                    <?php
                    $jsonFileAccessModel2 = new JsonFileAccessModel('allUsers');
                    $users = json_decode($jsonFileAccessModel2->read(), true);
                    $translators = array_filter($users, function ($user) {
                        return $user['status'] == 'translator';
                    });
                    ?>
                    <label>
                        Ответственный:
                        <select name="translator">
                            <option value="">Не назначать</option>
                            <?php
                            foreach ($translators as $translator) {
                                $tasks_num = $tasksList->getTasksNum($translator['email']);
                                $selected = ($task['translator'] == $translator['email']) ? 'selected' : '';
                                echo '<option value="' . $translator['email'] . '"' . $selected . '>' . $translator['name'] . ' (' . $tasks_num . ')' . '</option>';
                            }
                            ?>
                        </select>
                    </label>
                    <label>
                        Клиент:
                        <input type="text" name="client" value="<?= $task['client']; ?>">
                    </label>
                </div>

                <div class="form_wrapper_2">
                    <?php
                    $jsonFileAccessModel3 = new JsonFileAccessModel('languages');
                    $languages = json_decode($jsonFileAccessModel3->read(), true);
                    ?>
                    <label>
                        Язык оригинала:
                        <?php
                        foreach ($languages as $value) {
                            $attr = ($task['ref_lang'] == $value['id']) ? 'checked' : 'disabled';
                            echo '<label class="label-lang"><input type="radio" name="ref_lang" value="' . $value['id'] . '" ' . $attr . ' />' . $value['name'] . '</label>';
                        }
                        ?>
                    </label>
                </div>

                <div class="form_wrapper_3">
                    <label>
                        Языки перевода:
                        <?php
                        foreach ($languages as $key => $value) {
                            $checked = in_array($value['id'], $task['trans_lang']);
                            $checked = $checked ? 'checked' : '';
                            echo '<label class="label-lang"><input type="checkbox" name="trans_lang[' . $key . ']" value="' . $value['id'] . '" ' . $checked . ' />' . $value['name'] . '</label>';
                        }
                        ?>
                    </label>
                </div>
                <textarea name="text"><?= $jsonFileAccessModel->read(); ?></textarea>

                <div class="form_wrapper_4">

                    <label>
                        Статус задания:
                    </label>
                    <?php $checked = ($task['status'] == 'done') ? 'checked' : ''; ?>
                    <label class="label-status"><input type="radio" name="status" value="done" <?= $checked ?> />Выполнено</label>
                    <?php $checked = ($task['status'] == 'rejected') ? 'checked' : ''; ?>
                    <label class="label-status"><input type="radio" name="status" value="rejected" <?= $checked ?> />Отклонено</label>
                </div>
                <div class="form_wrapper_4">
                    <label>
                        Крайний срок
                        <input type="date" name="deadline" value="<?= $task['deadline'] ?>">
                    </label>
                    <button>Сохранить</button>
                </div>

            </form>
        </div>
    </div>

</div>

</div>
