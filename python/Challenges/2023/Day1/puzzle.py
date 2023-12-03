from itertools import combinations
import math
import re


class Puzzle:
    def first_part(self, input_string: str):
        values = [[*a] for a in input_string.split('\n')]

        suma = 0
        for value in values:
            foundFirst = False
            first = 0
            last = 0
            for char in value:
                if char.isdigit():
                    if foundFirst == False:
                        foundFirst = True
                        first = char
                    last = char

            number = first + last
            print(number)
            suma += int(number)

        return suma

    def second_part(self, input_string: str):
        def f(x):
            original = x
            word_to_number = {
                'one': 1,
                'two': 2,
                'three': 3,
                'four': 4,
                'five': 5,
                'six': 6,
                'seven': 7,
                'eight': 8,
                'nine': 9
            }

            pattern = re.compile(r'(zero|one|two|three|four|five|six|seven|eight|nine|\d)')
            matches = pattern.findall(x)
            first = matches[0]
            if first.isdigit() == False:
                first = word_to_number[first]

            last = matches[-1]
            if last.isdigit() == False:
                last = word_to_number[last]

            number = int(str(first) + str(last))


            for i, s in enumerate(['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine']):
                x = x.replace(s, s[0] + str(i + 1) + s[-1])
            z = re.findall(r'\d', x)
            if  number != int(z[0] + z[-1]) :
                print(original, number, int(z[0] + z[-1]))
            return int(z[0] + z[-1])

        # print(sum(map(f, open('input.txt'))))
        values = [a for a in input_string.split('\n')]
        print(sum(map(f, values)))
        return 1
        word_to_number = {
            'one': 1,
            'two': 2,
            'three': 3,
            'four': 4,
            'five': 5,
            'six': 6,
            'seven': 7,
            'eight': 8,
            'nine': 9
        }

        suma = 0
        pattern = re.compile(r'(zero|one|two|three|four|five|six|seven|eight|nine|\d)')
        for value in values:
            matches = pattern.findall(value)
            print(value)
            print(matches)
            if len(matches) == 1:
                print('single match')

            first = matches[0]
            if first.isdigit() == False:
                first = word_to_number[first]



            last = matches[-1]
            if last.isdigit() == False:
                last = word_to_number[last]

            number = str(first) + str(last)
            suma += int(number)
            print(first, last, number, suma)

        return suma
