<template>
    <div class="welcome">
      <div class="welcome-section">
        <h2 class="welcome-title">Guess Who's Back? ADMIN's Back!</h2>
        <section class="search-container">
          <form class="search-form" role="search">
            <label for="search-input" class="visually-hidden">Search your slang...</label>
            <input type="search" id="search-input" class="search-input" placeholder="Search your slang..." aria-label="Search your slang...">
            <button type="submit" class="search-button">
              <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/29febdd82fa653c3bfa21b2be25d8331191af8f5bcd2e611cb48f49ca70e8ace?apiKey=d314e47cd2b145d4ba1bdf6144e8401a" alt="Search Icon" class="search-icon">
            </button>
          </form>
        </section>
      </div>

      <div class="penguin">
        <img src="@/assets/welcome-admin.jpg" alt="User" height="250px" width="350px" />
      </div>
    </div>
</template>

<script>
</script>

<style>
.welcome {
  background-color: #FF9B3F;
  padding: 100px 100px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.welcome-section {
  flex: 1;
  margin-right: 2rem;
  width: fit-content;
}

.welcome-title {
  color: #000;
  text-align: center;
  font-family: Arial, Helvetica, sans-serif;
  font-style: normal;
  font-weight: 700;
  font-size: 30px;
  line-height: normal;
  margin-bottom: 10px;
}

.search-container {
  border-radius: 50px;
  background-color: rgba(255, 255, 255, 1);
  display: flex;
  margin-top: 0px;
  font-size: 20px;
  color: #6e6e6e;
  font-weight: 400;
  padding: 18px 30px;
  width: 500px;
  height: 40px;
  margin: auto;
}

@media (max-width: 991px) {
  .search-container {
    max-width: 100%;
    flex-wrap: wrap;
    padding: 0 20px;
  }
}

.search-form {
  display: flex;
  align-items: center;
  width: 100%;
}

.search-input {
  font-family: Inter, sans-serif;
  flex-grow: 1;
  flex-basis: auto;
  border: none;
  outline: none;
  font-size: inherit;
  color: inherit;
}

.visually-hidden {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0;
}

.search-button {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
}

.search-icon {
  aspect-ratio: 1.03;
  object-fit: auto;
  object-position: center;
  width: 36px;
}
</style>