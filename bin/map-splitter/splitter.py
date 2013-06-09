#!/usr/bin/python2
# -*- coding: utf-8 -*-

import Image
from sys import argv

def crop_image(img, region_size, region_step):
    for y in range(img.size[1] // region_step - 1):
        for x in range(img.size[0] // region_step - 1):
            box = (x * region_step, y * region_step, (x * region_step) + region_size[0], (y * region_step) + region_size[1])
            yield (x, y, image.crop(box))

if __name__ == '__main__':
    if len(argv) != 5:
        print('Usage: %s <filename> <region_width> <region_height> <region_step>' % argv[0])
        exit()

    image = Image.open(argv[1])
    region_size = (int(argv[2]), int(argv[3]))
    region_step = int(argv[4])

    for x, y, region in crop_image(image, region_size, region_step):
        new_image = Image.new('RGB', region_size, 255)
        new_image.paste(region)
        path = '%dx%d.png' % (x, y)
        new_image.save(path)
