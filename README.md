# ScoreboardCom Web Application

## Project Overview

ScoreboardCom is a simple LAMP-stack (Linux, Apache, MySQL, PHP) web application designed to track and display scores in real time during an event. Judges can submit scores for players, and the application automatically calculates total scores, displays rankings, and offers a public-facing scoreboard.

This project was built as part of a challenge to showcase backend and frontend integration using PHP and MySQL.

---

##  Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/scoreboardcom.git
```

### 2. Move Project to XAMPP `htdocs`

Place the entire `scoreboardcom` folder into the `htdocs` directory of your XAMPP installation:

```
C:\xampp\htdocs\scoreboardcom
```

### 3. Import the Database

1. Open **phpMyAdmin** in your browser (usually at `http://localhost/phpmyadmin`).
2. Create a new database named:

```
scoreboardcom
```

3. Open the SQL tab and run the following schema statements:

---

##  Database Schema

```sql
CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judge_name VARCHAR(100) NOT NULL,
    unique_ID VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(100) NOT NULL,
    player_ID VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judge_id INT NOT NULL,
    player_id INT NOT NULL,
    score INT NOT NULL,
    FOREIGN KEY (judge_id) REFERENCES judges(id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);
```

---

## How to Run

1. Start **Apache** and **MySQL** from XAMPP.
2. Visit the homepage:

```
http://localhost/scoreboardcom/index.php
```

3. Navigate through the app:

* **Admin:** Add or remove judges
* **Judges:** Authenticate and submit scores
* **Players:** Register to receive a unique Player ID
* **Scoreboard:** View rankings and score breakdowns

---

## Assumptions Made

* Judges are manually registered by an admin and authenticated via their `unique_ID`.
* Players only input their name; the system auto-generates a unique `player_ID`.
* A judge can vote only once per player.
* Players and judges are assumed to be present during the event and interacting via a single device.

---

## Design Decisions

### Database Design:

* Separated `judges`, `players`, and `scores` into individual tables for normalization.
* Used `FOREIGN KEY` constraints in `scores` to maintain data integrity.
* The `player_ID` and `unique_ID` fields ensure that users are referenced via friendly, unique identifiers.

### PHP Implementation:

* Sessions were used to keep track of judge login states.
* Form submissions are handled via `POST` with validation and redirection to avoid resubmission.
* A centralized `Database.php` class simplifies DB connection, querying, and escaping values.
* The scoreboard refreshes every 10 seconds using a meta tag, ensuring real-time updates.
* Search functionality filters players by their `player_ID` and highlights the row for better UX.

---

## Features to Add (Given More Time)

1. **Score Visualization:** Pie charts or bar graphs showing individual player scores.
2. **Player Images:** Allow players to upload an image during registration to display on the scoreboard.
3. **Judge Score Editing:** Allow judges to edit their submitted scores within a time limit.
4. **CSV Export:** Enable the admin to download all player scores and rankings as a CSV file.

---

## Acknowledgments

Designed and developed by **Nick Temesi** as part of a technical challenge.

---

## Feedback & Contributions

Feel free to fork the project, suggest improvements, or create pull requests. Let's make event scoring better, together!

---
