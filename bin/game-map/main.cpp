/**
 * File:   main.cpp
 * Author: ismd
 *
 * Created on 25 Май 2012 г., 14:18
 */

#include <cstdlib>
#include <iostream>
#include <sstream>
#include <ImageMagick/Magick++.h>
#include <cmath>
#include <string.h>
#include <stdlib.h>

using namespace std;

void print_usage(char* bin_filename) {
    cout << "Использование: " << bin_filename <<
            " -width <Ширина клетки в пикселях>" <<
            " -height <Высота клетки в пикселях>" <<
            " -horizontal <Количество клеток по горизонтали>" <<
            " -vertical <Количество клеток по вертикали> <filename>" << endl;
}

int main(int argc, char** argv) {
    if (argc < 10) {
        print_usage(argv[0]);
        return EXIT_FAILURE;
    }

    char* map_filename         = "";
    int cell_width             = 0,
        cell_height            = 0,
        image_horizontal_cells = 0,
        image_vertical_cells   = 0;

    // Обрабатываем аргументы
    for (int i = 1; i < argc; i++) {
        if (strcmp(argv[i], "-width") == 0) {
            if (cell_width != 0) {
                print_usage(argv[0]);
                return EXIT_FAILURE;
            }

            cell_width = atoi(argv[++i]);
            continue;
        }

        if (strcmp(argv[i], "-height") == 0) {
            if (cell_height != 0) {
                print_usage(argv[0]);
                return EXIT_FAILURE;
            }

            cell_height = atoi(argv[++i]);
            continue;
        }

        if (strcmp(argv[i], "-horizontal") == 0) {
            if (image_horizontal_cells != 0) {
                print_usage(argv[0]);
                return EXIT_FAILURE;
            }

            image_horizontal_cells = atoi(argv[++i]);
            continue;
        }

        if (strcmp(argv[i], "-vertical") == 0) {
            if (image_vertical_cells != 0) {
                print_usage(argv[0]);
                return EXIT_FAILURE;
            }

            image_vertical_cells = atoi(argv[++i]);
            continue;
        }

        if (strcmp(map_filename, "") != 0) {
            print_usage(argv[0]);
            return EXIT_FAILURE;
        }

        map_filename = argv[i];
    }

    Magick::Image map;

    // Загружаем полностью карту
    try {
        cout << "Загружаем карту `" << map_filename << "'" << endl;
        map.read(map_filename);
    } catch (exception &error) {
        cout << error.what() << endl;
        return EXIT_FAILURE;
    }

    stringstream ss_x, ss_y;

    // Проверяем размеры
    ss_x << cell_width;
    ss_y << cell_height;
    cout << "Проверяем размеры карты (должна быть пропорциональна "
         << ss_x.str() << "x" << ss_y.str() << " px)" << endl;
    ss_x.str("");
    ss_y.str("");

    int map_width = map.size().width();
    int map_height = map.size().height();

    if (map_width % cell_width != 0 || map_height % cell_height != 0) {
        cout << "Bad map size" << endl;
        return EXIT_FAILURE;
    }

    Magick::Image cell;
    stringstream filename;

    int image_count_columns = map_width  / cell_width;
    int image_count_rows    = map_height / cell_height;

    ss_x << image_count_columns;
    ss_y << image_count_rows;
    cout << "Размер карты: " << ss_x.str() << 'x' << ss_y.str() << " клеток" << endl;
    ss_x.str("");
    ss_y.str("");

    // Удаляем старые части карты
    cout << "Удаляем старые части карты: rm -f *x*.png" << endl;
    system("rm -f *x*.png");

    int image_part_width  = cell_width * image_horizontal_cells;
    int image_part_height = cell_height * image_vertical_cells;
    int image_part_left_position;
    int image_part_top_position;

    // Создаём части карты
    ss_x << image_horizontal_cells;
    ss_y << image_vertical_cells;
    cout << "Создаём части карты размером " << ss_x.str() << 'x' << ss_y.str() << " клеток" << endl;
    ss_x.str("");
    ss_y.str("");
    for (int y = 0; y < image_count_rows; y++) {
        for (int x = 0; x < image_count_columns; x++) {
            if (x < image_horizontal_cells / 2) {
                image_part_left_position = 0;
            } else if (image_count_columns - x - 1 < image_horizontal_cells / 2) {
                image_part_left_position = map_width - image_horizontal_cells * cell_width;
            } else {
                image_part_left_position = (x - floor(image_horizontal_cells / 2)) * cell_width;
            }

            if (y < image_vertical_cells / 2) {
                image_part_top_position = 0;
            } else if (image_count_rows - y - 1 < image_vertical_cells / 2) {
                image_part_top_position = map_height - image_vertical_cells * cell_height;
            } else {
                image_part_top_position = (y - floor(image_vertical_cells / 2)) * cell_height;
            }

            cell = map;
            cell.crop( Magick::Geometry(image_part_width,
                    image_part_height,
                    image_part_left_position,
                    image_part_top_position) );

            filename << x << 'x' << y << ".png";
            cell.write( filename.str() );

            filename.str("");
        }
    }

    return EXIT_SUCCESS;
}
