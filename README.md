# Hangman API
School assignment to build hangman API with symfony 2
## Assignment
In this assignment we ask you to implement a minimal version of a hangman API using the following resources below: 
### Start a new game
**POST:** ```/games```
At the start of the game a random word should be picked from this list. 
### Guess a started game
**PUT:** ```/games/:id```
Guessing a correct letter doesn’t decrement the amount of tries left. Only valid characters are a-z 

### Response (JSON)
Every response should contain the following fields: 
* _word_: representation of the word that is being guessed. Should contain dots for letters that have not been guessed yet.
* _tries_left_: the number of tries left to guess the word (starts at 11) 
* _status_: current status of the game (busy|fail|success)

#### Example response (JSON):
```json
  {
  "word": "aw.so..",
  "tries_left": 11,
  "status": "busy"
  }
```
