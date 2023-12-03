import re


class Bag:
    def __init__(self, bag_name):
        self.bag_name = bag_name
        self.parents = {}
        self.childs = {}

    def add_parent_bag(self, parent):
        self.parents[parent.bag_name] = parent

    def add_child_bag(self, child, count):
        self.childs[child.bag_name] = {
            'bag': child,
            'count': count
        }


class Puzzle:
    def first_part(self, input_string):
        bags = [a for a in input_string.split('\n')]
        coll = {}
        shiny_bag = Bag('shiny gold')
        coll['shiny gold'] = shiny_bag
        for bag_text in bags:
            bag_key, contains_bags = parse_bag_rules(bag_text)
            if bag_key in coll:
                parent_bag = coll[bag_key]
            else:
                parent_bag = Bag(bag_key)
                coll[bag_key] = parent_bag

            for count, child_bag_key in contains_bags:
                if child_bag_key in coll:
                    child_bag = coll[child_bag_key]
                else:
                    child_bag = Bag(child_bag_key)
                    coll[child_bag_key] = child_bag
                child_bag.add_parent_bag(parent_bag)

        available_bags = {}
        listt = []
        for key, bag in shiny_bag.parents.items():
            listt.append(bag)

        while listt:
            bag = listt.pop(0)
            available_bags[bag.bag_name] = 1
            for key, parent_bag in bag.parents.items():
                listt.append(parent_bag)

        return len(available_bags)

    def second_part(self, input_string):
        bags = [a for a in input_string.split('\n')]
        coll = {}
        shiny_bag = Bag('shiny gold')
        coll['shiny gold'] = shiny_bag
        for bag_text in bags:
            bag_key, contains_bags = parse_bag_rules(bag_text)
            if bag_key in coll:
                parent_bag = coll[bag_key]
            else:
                parent_bag = Bag(bag_key)
                coll[bag_key] = parent_bag

            for count, child_bag_key in contains_bags:
                if child_bag_key in coll:
                    child_bag = coll[child_bag_key]
                else:
                    child_bag = Bag(child_bag_key)
                    coll[child_bag_key] = child_bag
                child_bag.add_parent_bag(parent_bag)
                parent_bag.add_child_bag(child_bag, count)

        result = 0
        for key, bag_info in shiny_bag.childs.items():
            result += bag_info['count'] * count_bags(bag_info['bag'])

        return result


def count_bags( bag):
    if len(bag.childs) == 0:
        return 1
    result = 0
    for key, bag_info in bag.childs.items():
        result += bag_info['count'] * count_bags(bag_info['bag'])

    return result + 1


# chatGPT FTW
def parse_bag_rules(text):
    # Regular expression to match bag rules
    pattern = re.compile(r'(\w+ \w+) bags contain (.+?)\.')

    # Match the pattern in the input text
    match = pattern.match(text)

    if match:
        # Extract bag color and contained bags information
        bag_color = match.group(1)
        contained_bags_text = match.group(2)
        contained_bags_text = re.sub(r'no', '0', contained_bags_text)


        # Split the contained bags text into individual bags
        contained_bags = [bag.strip() for bag in contained_bags_text.split(',')]


        # Parse each contained bag to get the information
        contains_info = []
        for bag in contained_bags:
            bag_match = re.match(r'(\d+) (\w+ \w+) bags?', bag)
            if bag_match:
                count = int(bag_match.group(1))
                color = bag_match.group(2)
                contains_info.append((count, color))

        return bag_color, contains_info

        # Return the parsed information
        # return f"{bag_color} bag contains {', '.join(f'{count} {color}' for count, color in contains_info)}", \
        #        f"What bags are in the {bag_color} bag: {', '.join(color for _, color in contains_info)}"

    return None, None
