import re


class Puzzle:
    def first_part(self, input_string: str):
        return sum(get_coded_number(row) for row in [a for a in input_string.split(',')])

    def second_part(self, input_string: str):
        pattern = r'(?P<hash>[a-zA-Z]{2,})(?P<sign>[-=])(?P<numbers>\d*)'

        boxes = {}
        for row in [re.match(pattern, a).groupdict() for a in input_string.split(',')]:
            coded_number = get_coded_number(row['hash'])
            boxes.setdefault(coded_number, {})

            if row['sign'] == '=':
                boxes[coded_number][row['hash']] = {
                    'hash': row['hash'],
                    'strength': row['numbers']
                }

            if row['sign'] == '-' and row['hash'] in boxes[coded_number]:
                del boxes[coded_number][row['hash']]

        suma = sum((box_key + 1) * (index + 1) * int(value['strength'])
                   for box_key, box_values in boxes.items()
                   for index, (key, value) in enumerate(box_values.items()))

        return suma


def get_coded_number(string):
    current_value = 0
    for char in string:
        ord_value = ord(char)
        current_value += ord_value
        current_value = (current_value * 17) % 256

    return current_value
