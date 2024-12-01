class Puzzle:
    def first_part(self, input_string: str):
        rows = [a for a in input_string.split('\n')]

        suma = 0
        fl = []
        sl = []
        for row in rows:
            [first, second] = row.split('   ')
            fl.append(first);
            sl.append(second);

        fl.sort()
        sl.sort()

        for row_number in range(len(fl)):
            print(row_number)
            suma += abs(int(sl[row_number]) - int(fl[row_number]))

        return suma

    def second_part(self, input_string: str):
        rows = [a for a in input_string.split('\n')]

        suma = 0
        fl = []
        sl = []
        for row in rows:
            [first, second] = row.split('   ')
            fl.append(first);
            sl.append(second);

        for number in fl:
            occ = 0
            for comp_number in sl:
                if number == comp_number:
                    occ += 1
            suma += int(number) * occ

        return suma
