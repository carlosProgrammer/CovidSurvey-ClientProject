<?php

require_once 'db/db_config.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';

?>


<form id="Survey-form" action="success.php" method="post">

    
   
    <div class="form-control">
        <label for="age" id="label-age">Select your age group</label>
        <select id="age" name="age">
            <option>Select an option </option>
            <?php foreach($ages as $age): ?>
            
            <option>
                <?= $age['option_content']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-control">

        <label>Select your gender</label>
            
            <label for="gender">
                <?php foreach($genders as $gender): ?>
                    <input type="radio" 
                        id="<?= $gender['option_id']; ?>" 
                        name="gender"
                        value="<?= $gender['option_content']; ?>"   /> 
                            <?= $gender['option_content']; echo "<br>" ?>
            </label>
                <?php endforeach; ?>
    </div>

    <div class="form-control">
        <label for="Race" id="label-name">Race</label>
        <input type="text" id="race" placeholder="Enter a race" name="race" />
    </div>
    <div class="form-control">
        <label for="County" id="label-name">Select the county you live in</label>
        <select id="county" name="county">
            <option>Select an option </option>
            <?php foreach($counties as $county): ?>
            
            <option>
                <?= $county['option_content']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-control">
        <label for="roles"> Which option best describes your role?</label>
        <select id="roles" name="roles">
            <option value="null">Select an option </option>
            <?php foreach($roles as $role): ?>
            <option>
                <?= $role['option_content']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-control">
        <label for="affected"> How deeply has covid-19 affected you??</label>
        <select id="affected" name="affected">
            <option>Select an option </option>
            <?php foreach($affecteds as $affected): ?>
            <option>
                <?= $affected['option_content']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-control">
        <label>In what way has covid-19 affected you?<small>(select all that apply)</small></label>
        <label for="effects">
                <?php foreach($effects as $effect): ?>
                    <input type="checkbox" 
                        id="<?= $effect['option_id']; ?>" 
                        name="effects"
                        value="<?= $effect['option_content']; ?>"   /> 
                            <?= $effect['option_content']; echo "<br>" ?>
            </label>
                <?php endforeach; ?>
    </div>
    <div class="form-control">
        <label for="measures">what measures are you taking to prevent from covid-19?(select all that apply)</label>
        <select id="measures" name="measures">
            <option>Select an option </option>
            <?php foreach($measures as $measure): ?>
            <option>
                <?= $measure['option_content']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-control">
        <label for="test">Were you or your family tested positive for covid-19?</label>
        <select id="test" name="test">
            <option>Select an option </option>
            <?php foreach($tests as $test): ?>
            <option>
                <?= $test['option_content']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-control">
        <label for="text">If yes, how many?</label>
        <input type="number" id="howMany" name="howMany" placeholder="Enter the number" />
    </div>
    <div class="form-control">
        <label for="condition">What are the conditions of the people infected by covid-19?</label>
        <select id="condition" name="condition">
            <option>Select an option </option>
            <?php foreach($conditions as $condition): ?>
            <option>
                <?= $condition['option_content']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-control">
        <label for="comments">Any comments of suggestions?</label>
        <textarea name="comments" id="comments" placeholder="Enter your comment here..." cols="60"></textarea>
    </div>

    <input id="submit" type="submit"/>
</form>

<?php require_once 'includes/footer.php'; ?>