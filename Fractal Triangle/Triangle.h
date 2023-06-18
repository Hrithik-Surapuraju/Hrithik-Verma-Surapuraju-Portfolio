#ifndef triangle // NOLINT
#define triangle // NOLINT
#include <cmath>
#include <SFML/Graphics.hpp>

#define PI   3.14159265

class Triangle: public sf::Drawable {
 public:
    Triangle(int len, int x, int y);
    ~Triangle();
    int get_center_x();
    int get_center_y();
    int get_baselen();
    void get_points(int* x1, int* y1, int* x2, int* y2,
                    int* x3, int* y3);
    void set_color(int c);

 private:
    virtual void draw(sf::RenderTarget& target,
                      sf::RenderStates states) const {
        sf::Color cl[5] = {sf::Color::White, sf::Color::Red,
            sf::Color::Green, sf::Color::Yellow, sf::Color::Magenta};

        sf::Vertex line1[] = {
            sf::Vertex(sf::Vector2f(_x1, _y1), cl[_color]),
            sf::Vertex(sf::Vector2f(_x2, _y2), cl[_color])
        };
        sf::Vertex line2[] = {
            sf::Vertex(sf::Vector2f(_x2, _y2), cl[_color]),
            sf::Vertex(sf::Vector2f(_x3, _y3), cl[_color])
        };
        sf::Vertex line3[] = {
            sf::Vertex(sf::Vector2f(_x3, _y3), cl[_color]),
            sf::Vertex(sf::Vector2f(_x1, _y1), cl[_color])
        };
        target.draw(line1, 2, sf::Lines);
        target.draw(line2, 2, sf::Lines);
        target.draw(line3, 2, sf::Lines);
    }
    int _len, _x, _y;
    int _x1, _y1, _x2, _y2, _x3, _y3;
    int _color;
};

#endif  // NOLINT
