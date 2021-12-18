# Advent Of Code solutions in PHP
Personal solutions and small framework to help to solve Advent Of Code puzzle.

## Requirements
- PHP >=7.1.3
- Composer

## Installation

- Clone repository
- Run `composer install`
- Create your locale `.env` file by copying `.end.dist`.
- Pull adventofcode.com session token (You can use any modern browser developer tools) and update `AOC_SESSIONID` value in `.env` file

## Usage
All puzzles are placed under `src/YearX/DayX` structure.
Each day has files:
- Puzzle.php file, where first and second parts are solved separately.
- PuzzleTest.php file, where test inputs for each puzzle part are placed and corresponding answers.
- input.txt - this is your main puzzle input, which is used to generate the answer.

Each day could follow this workflow to solve the puzzles:
1. Generate structure for a puzzle by running `app p:g <day>` command.
2. Downloading the input by running `app p:d:i <day>` command.
3. Creating solution
4. Optionally updating PuzzleTest with tests
5. And then running the solution with command `app p:r <day> <part:first|second>`

### Solve the puzzle:
````
Usage:
 app puzzle:run [<day>] [<part>] [options]
 app p:r [<day>] [<part>] [options]

Arguments:
 day                   Day of the puzzle
 part                  Available options: 'first','secong'. Part of the puzzle

Options:
     --year[=YEAR]     Year of the puzzle [default: current year]
     -t                Execute tests
     --file[=FILE]     Execute puzzle with given input from the file
    
To Be Added:
Option --send
   With this option, result from the puzzle will be sent to adventofcode.com
   For this you must have updated .env file with session ID
````
### Create structure for a given puzzle
````
Usage:
 app puzzle:generate [<day>] [options]
 app p:g [<day>] [options]

Arguments:
 day                   Day of the puzzle

Options:
     --year[=YEAR]     Year of the puzzle [default: current year]
     --force -f        Replace current structure with new one
````
### Download puzzle input from adventofcode
For command to work, you must have updated .env file with session ID
````
Download puzzle input from adventofcode.com.
For this you must have updated .env file with session ID

Usage:
 app puzzle:download:input [<day>] [options]
 app p:d:i [<day>] [options]

Arguments:
 day                   Day of the puzzle

Options:
     --year[=YEAR] -y  Year of the puzzle [default: current year]
````

### ToDo
- Fix the option to send the puzzle result to Advent Of Code
- Add docker support
- Update `puzzle:run` command to have shorter syntax when selecting part of the puzzle.
