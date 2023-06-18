// Copyright 2022 Hrithik Verma Surapuraju
#ifndef CELESTIAL_BODY // NOLINT
#define CELESTIAL_BODY // NOLINT
#include <iostream>
#include <fstream>
#include <string>
#include <SFML/Graphics.hpp>


class CelestialBody : sf::Drawable {
 public:
    CelestialBody(double cxpos, double cypos, double cxvel, double cyvel,
    double cmass, std::string cfilename);
 private:
    double xpos;
    double ypos;
    double xvel;
    double yvel;
    double mass;
    std::string filename;
    sf::Image image;
    sf::Texture texture;
    mutable sf::Sprite sprite;
    void draw(sf::RenderTarget &target, sf::RenderStates states)const; // NOLINT
};

#endif // NOLINT