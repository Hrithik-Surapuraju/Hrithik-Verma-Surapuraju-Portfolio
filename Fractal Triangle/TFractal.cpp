#include "Triangle.h"
#include <cmath>
#include <iostream>
#include <string>
#include <SFML/Graphics.hpp>

void fTree(const sf::RenderWindow& w, Triangle tr, int depth) {
    if (depth == 0) return;
    int x1, y1, x2, y2, x3, y3;
    int x, y;

    tr.get_points(&x1, &y1, &x2, &y2, &x3, &y3);
    int len = tr.get_baselen()/2;

    tr.set_color(depth % 5);
    ((sf::RenderWindow&) w).draw(tr);

    // 1st child
    x = x1;
    y = y1 - 2 * sqrt(pow(len, 2)/12);
    Triangle tr1(len, x, y);
    fTree(w, tr1, depth-1);

    // 2nd child
    x = x2 + len / 2;
    y = y2 + sqrt(pow(len, 2)/12);
    Triangle tr2(len, x, y);
    fTree(w, tr2, depth-1);

    // 3rd child
    x = x3 - len / 2;
    y = y3 + sqrt(pow(len, 2)/12);
    Triangle tr3(len, x, y);
    fTree(w, tr3, depth-1);
}

int main(int argc, char *argv[]) {
    if (argc != 3) {
        std::cout << "Usage: fractal <length> <depth>" << std::endl;
        exit(1);
    }
    int baselen = std::stoi(argv[1]);
    int depth = std::stoi(argv[2]);

    sf::RenderWindow window(sf::VideoMode(3.5*baselen, 3*baselen), "Triangle");

    Triangle tr(baselen, 1.5*baselen, 1.5*baselen);
    tr.set_color(depth % 5);

    while (window.isOpen()) {
        sf::Event event;
        while (window.pollEvent(event)) {
            if (event.type == sf::Event::Closed)
                window.close();
        }
        window.clear();
        fTree(window, tr, depth);
        window.display();
    }
    return 0;
}
