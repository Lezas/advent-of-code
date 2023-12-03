from itertools import combinations
import math
import re


class Puzzle:
    def first_part(self, input_string: str):
        rows = [a for a in input_string.split('\n')]

        print(rows)

        max_values = {
            'red': 12,
            'green': 13,
            'blue': 14
        }

        suma = 0
        for row in rows:
            [game_number_with_text, games] = row.split(':')
            [string, game_number] = game_number_with_text.split()
            possible = True
            for game in games.split(';'):
                # print(game)
                for cubes in game.split(','):
                    [number_of_cubes, color] = cubes.split()
                    # print(max_values[color],number_of_cubes )
                    if max_values[color] < int(number_of_cubes):
                        possible = False
                        # print('game ', game_number, ' not possible')
                        continue

            if possible:
                suma += int(game_number)

        return suma

    def second_part(self, input_string: str):
        rows = [a for a in input_string.split('\n')]

        print(rows)

        max_values = {
            'red': 12,
            'green': 13,
            'blue': 14
        }

        suma = 0
        for row in rows:
            [game_number_with_text, games] = row.split(':')
            [string, game_number] = game_number_with_text.split()
            max_values = {
                'red': 0,
                'green': 0,
                'blue': 0
            }
            for game in games.split(';'):
                # print(game)
                for cubes in game.split(','):
                    [number_of_cubes, color] = cubes.split()
                    # print(max_values[color],number_of_cubes )
                    if max_values[color] < int(number_of_cubes):
                        max_values[color] = int(number_of_cubes)

            suma += max_values['green'] * max_values['red'] * max_values['blue']

        return suma
