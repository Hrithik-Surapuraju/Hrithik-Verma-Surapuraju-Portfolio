// Copyright 2022 Hrithik Verma Surapuraju
#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include <SFML/Graphics.hpp>
#include "universe.h" // NOLINT

Universe::Universe(std::string filename) {
    std::ifstream planets;
    planets.open(filename);
    std::string line;
    double xpos;
    double ypos;
    double xvel;
    double yvel;
    double mass;
    std::vector<int> body;
    std::string planet;

    if (planets.is_open() == 0) {
        exit(0);
    }

    planets >> num;
    planets >> radius;

    for (int i = 0; i < num; i++) {
        planets >> xpos >> ypos >> xvel >> yvel >> mass;
    }

    planets.close();
}

// std::istream &std::operator>>(std::istream  &input, const CelestialBody &c)
// {
//     input >> c;
// }
