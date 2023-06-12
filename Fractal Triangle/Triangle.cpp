#include "Triangle.h"
#include <cmath>
#include <SFML/Graphics.hpp>

Triangle::Triangle(int baselen, int x, int y) {
    _x = x;
    _y = y;
    _len = baselen;
    _x1 = _x - _len / 2;
    _y1 = _y - sqrt(pow(_len, 2)/12);
    _x2 = _x1 + _len;
    _y2 = _y1;
    _x3 = _x1 + (_len * cos(60.0*PI/180));
    _y3 = _y1 + (_len * sin(60.0*PI/180));
}

Triangle::~Triangle() {
}

int Triangle::get_center_x() {
    return _x;
}

int Triangle::get_center_y() {
    return _y;
}

int Triangle::get_baselen() {
    return _len;
}

void Triangle::get_points(int* x1, int* y1, int* x2,
                          int* y2, int* x3, int* y3) {
    *x1 = _x1;
    *y1 = _y1;
    *x2 = _x2;
    *y2 = _y2;
    *x3 = _x3;
    *y3 = _y3;
}

void Triangle::set_color(int clr) {
    _color = clr;
}
