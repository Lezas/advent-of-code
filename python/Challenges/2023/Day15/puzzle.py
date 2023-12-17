from functools import lru_cache

class Puzzle:
    def first_part(self, input_string: str):
        rows = [[*a] for a in input_string.split(',')]
        suma = 0
        for row in rows:

            current_value = 0
            for char in row:
                ord_value = ord(char)
                current_value += ord_value
                current_value = (current_value * 17)% 256
                print(char, current_value)

            suma += current_value

        return suma

    # 160 too low
    def second_part(self, input_string: str):
        grid = [[*a] for a in input_string.split('\n')]


        return suma
