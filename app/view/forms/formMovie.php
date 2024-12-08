<?php 
    ob_start();
?>
<script src="public/js/formMovie.js" defer></script>
<div class="add-movie add-container">
    <h1>Add a new Movie</h1>
    <form action="" method="POST">
        <div class="inner-form">
            <div class="main-content">
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="movieTitle">Title</label>
                            <input type="text" name="movieTitle" id="movieTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="releaseDate">Release Date</label>
                            <input type="date" name="releaseDate" id="releaseDate" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="number" name="duration" id="duration" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <input type="number" name="note" id="note" min="0" max="5">
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="bannerUrl">Banner Url</label>
                            <input type="text" name="bannerUrl" id="bannerUrl">
                        </div>
                        <div class="form-group">
                            <label for="posterUrl">Poster Url</label>
                            <input type="text" name="posterUrl" id="posterUrl">
                        </div>
                        <div class="form-group">
                            <label for="director">Director</label>
                            <div class="select-wrapper">
                                <select name="director" id="director">
                                    <option value="0" selected>None</option>
                                    <?php foreach($directors as $director) : ?>
                                        <option value="<?= $director["id_director"] ?>"><?= $director["full_name"] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <p class="subtext">Can't find your director ? <a href="./?action=form&entity=persons&operation=add">Add one</a></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="synopsis">Synopsis</label>
                    <textarea name="synopsis" id="synopsis" rows="4"></textarea>
                </div>
            </div>
            <div class="side-content">
                <div class="side-header">
                    <h3>Casting</h3>
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Look for an actor">
                        <i class="fas fa-search search-icon"></i>
                        <div class="search-results"></div>
                    </div>
                </div>
                <div class="actors-field">
                    
                </div>
            </div>
        </div>
        <button type="submit" name="submit" class="submit-btn">Send</button>
    </form>
</div>

<?php
$title = "Add a movie";
$content = ob_get_clean();

require 'view/forms/formTemplate.php';