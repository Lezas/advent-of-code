import re


class Puzzle:
    def first_part(input_string: str):
        passports = [a.split() for a in input_string.split('\n\n')]

        necessary_items = [
            'byr',
            'iyr',
            'eyr',
            'hgt',
            'hcl',
            'ecl',
            'pid',
        ]

        not_found = 0

        for passport in passports:
            for item in necessary_items:
                found = 0
                for passport_item in passport:
                    if item in passport_item:
                        found = 1
                        break
                if found == 0:
                    not_found += 1
                    break

        return len(passports) - not_found

    def second_part(self, input_string):
        passports = [a.split() for a in input_string.split('\n\n')]

        necessary_items = [
            'byr',
            'iyr',
            'eyr',
            'hgt',
            'hcl',
            'ecl',
            'pid',
        ]

        not_found = 0

        for passport in passports:
            for item in necessary_items:
                found = False
                for passport_item in passport:
                    if item in passport_item:
                        do = f"validate_{item}"
                        value = passport_item.split(":")[1]
                        if hasattr(self, do) and callable(func := getattr(self, do)):
                            found = func(value)
                        break
                if found == False:
                    not_found += 1
                    break

        return len(passports) - not_found

    def validate_byr(self, input: str):
        return Puzzle.is_number_in_range(input, 1920, 2002)

    def validate_iyr(self, input: str):
        return Puzzle.is_number_in_range(input, 2010, 2020)

    def validate_eyr(self, input: str):
        return Puzzle.is_number_in_range(input, 2020, 2030)

    def validate_hgt(self, input: str):
        # Define the regular expression pattern to match the input
        pattern = re.compile(r'^(\d+)(cm|in)$')

        # Use regular expression to match the pattern
        match = pattern.match(input)

        # Check if the input matches the pattern
        if match:
            # Extract the number and unit from the matched groups
            number, unit = match.groups()

            # Convert the number to an integer
            number = int(number)

            # Validate based on the unit
            if unit == 'cm' and 150 <= number <= 193:
                return True
            elif unit == 'in' and 59 <= number <= 76:
                return True

        # If the input does not match the pattern or the criteria, return False
        return False

    def validate_hcl(self, input: str):
        pattern = re.compile(r'^#[0-9a-fA-F]{6}$')

        # Use regular expression to match the pattern
        match = pattern.match(input)

        # Check if the input matches the pattern
        return bool(match)

    def validate_ecl(self, input: str):
        # Define a set of valid eye colors
        valid_eye_colors = {"amb", "blu", "brn", "gry", "grn", "hzl", "oth"}

        # Check if the input string is in the set of valid eye colors
        return input in valid_eye_colors

    def validate_pid(self, input: str):
        return input.isdigit() and len(input) == 9

    def is_number_in_range(s: str, lower_limit, upper_limit):
        if s.isdigit():
            number = int(s)
            if lower_limit <= number <= upper_limit:
                return True
        return False
