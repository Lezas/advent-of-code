from functools import cmp_to_key


def compare_highest_card(obj1, obj2):
    char_strength = {
        'A': 14,
        'K': 13,
        'Q': 12,
        'J': 11,
        'T': 10,
    }
    for i in range(len(obj1['hand'])):
        char1 = obj1['hand'][i]
        if char1 in char_strength:
            str1 = char_strength[char1]
        else:
            str1 = int(char1)
        char2 = obj2['hand'][i]
        if char2 in char_strength:
            str2 = char_strength[char2]
        else:
            str2 = int(char2)

        if str1 < str2:
            return -1
        elif str1 > str2:
            return 1

    return 0


def compare_highest_card_part_two(obj1, obj2):
    char_strength = {
        'A': 14,
        'K': 13,
        'Q': 12,
        'T': 10,
        'J': 1,
    }
    for i in range(len(obj1['hand'])):
        char1 = obj1['hand'][i]
        if char1 in char_strength:
            str1 = char_strength[char1]
        else:
            str1 = int(char1)
        char2 = obj2['hand'][i]
        if char2 in char_strength:
            str2 = char_strength[char2]
        else:
            str2 = int(char2)

        if str1 < str2:
            return -1
        elif str1 > str2:
            return 1

    return 0


def custom_compare_part_one(obj1, obj2):
    if obj1['type'] == obj2['type']:
        return compare_highest_card(obj1, obj2)

    if obj1['type_rank'] < obj2['type_rank']:
        return -1
    elif obj1['type_rank'] > obj2['type_rank']:
        return 1
    else:
        return 0


def custom_compare_part_two(obj1, obj2):
    if obj1['type_rank'] == obj2['type_rank']:
        return compare_highest_card_part_two(obj1, obj2)

    if obj1['type_rank'] < obj2['type_rank']:
        return -1
    elif obj1['type_rank'] > obj2['type_rank']:
        return 1
    else:
        return 0


class Puzzle:
    def first_part(self, input_string: str):
        rows = [a.split() for a in input_string.split('\n')]
        hands = []
        for row in rows:
            hand = row[0]
            if self.five_of_kind(hand):
                hand_type = 'five_of_kind'
                hand_rank = 7
            elif self.four_of_kind(hand):
                hand_type = 'four_of_kind'
                hand_rank = 6
            elif self.full_house(hand):
                hand_type = 'full_house'
                hand_rank = 5
            elif self.three_of_a_kind(hand):
                hand_type = 'three_of_a_kind'
                hand_rank = 4
            elif self.two_pairs(hand):
                hand_type = 'two_pairs'
                hand_rank = 3
            elif self.one_pair(hand):
                hand_type = 'one_pair'
                hand_rank = 2
            else:
                hand_type = 'high_card'
                hand_rank = 1

            hand = {
                'hand': row[0],
                'bid': int(row[1]),
                'type': hand_type,
                'type_rank': hand_rank,
            }

            hands.append(hand)

        sorted_list = sorted(hands, key=cmp_to_key(custom_compare_part_one))

        suma = 0
        for i in range(len(sorted_list)):
            value = (i + 1) * sorted_list[i]['bid']
            suma += (i + 1) * sorted_list[i]['bid']
        return suma

    def five_of_kind(self, hand):
        return all(char == hand[0] for char in hand)

    def four_of_kind(self, hand):
        return any(hand.count(char) == 4 for char in set(hand))

    def full_house(self, hand):
        counts = [hand.count(char) for char in set(hand)]
        return 2 in counts and 3 in counts

    def three_of_a_kind(self, hand):
        return any(hand.count(char) == 3 for char in set(hand))

    def two_pairs(self, hand):
        counts = [hand.count(char) for char in set(hand)]
        return counts.count(2) == 2

    def one_pair(self, hand):
        return any(hand.count(char) == 2 for char in set(hand))

    def second_part(self, input_string: str):
        rows = [a.split() for a in input_string.split('\n')]
        hands = []
        possible_cards = ['A', 'K', 'Q', 'T', '9', '8', '7', '6', '5', '4', '3', '2']
        for row in rows:
            hand = row[0]
            possible_hands = self.generate_possible_hands(hand, possible_cards)
            max_rank = 0
            for possible_hand in possible_hands:
                if self.five_of_kind(possible_hand):
                    hand_rank = 7
                elif self.four_of_kind(possible_hand):
                    hand_rank = 6
                elif self.full_house(possible_hand):
                    hand_rank = 5
                elif self.three_of_a_kind(possible_hand):
                    hand_rank = 4
                elif self.two_pairs(possible_hand):
                    hand_rank = 3
                elif self.one_pair(possible_hand):
                    hand_rank = 2
                else:
                    hand_rank = 1

                if hand_rank > max_rank:
                    max_rank = hand_rank

            hand = {
                'hand': row[0],
                'bid': int(row[1]),
                'type_rank': max_rank,
            }

            hands.append(hand)

        sorted_list = sorted(hands, key=cmp_to_key(custom_compare_part_two))

        suma = 0
        for i in range(len(sorted_list)):
            suma += (i + 1) * sorted_list[i]['bid']
        return suma

    def generate_possible_hands(self, hand, possible_cards):
        if 'J' not in hand:
            return [hand]

        positions = [index for index, char in enumerate(hand) if char == 'J']
        possible_hands = [hand]

        for position in positions:
            possible_hands = [new_hand[:position] + possible_card + new_hand[position + 1:] for new_hand in
                              possible_hands for possible_card in possible_cards]

        return possible_hands
