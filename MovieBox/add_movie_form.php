 <?php include 'includes/header.php'; ?>
<h1>Add Movie (admin)</h1>
<form method="post" action="add_movie.php" enctype="multipart/form-data">
  <label>Title<input name="title" required></label>
  <label>Type<input name="type"></label>
  <label>Director<input name="director"></label>
  <label>Cast<textarea name="cast"></textarea></label>
  <label>Country<input name="country"></label>
  <label>Release Year<input name="release_year" type="number"></label>
  <label>Rating<input name="rating"></label>
  <label>Duration<input name="duration"></label>
  <label>Genres (comma separated)<input name="listed_in"></label>
  <label>Description<textarea name="description"></textarea></label>
  <label>Poster Image<input type="file" name="image"></label>
  <button type="submit">Add Movie</button>
</form>
<?php include 'includes/footer.php'; ?>
