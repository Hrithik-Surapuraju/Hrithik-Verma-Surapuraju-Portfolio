// Copyright 2022 Hrithik Verma Surapuraju
#ifndef UNIVERSE // NOLINT
#define UNIVERSE // NOLINT

#include <iostream>
#include <fstream>
#include <vector>
#include <string>
#include <SFML/Graphics.hpp>
#include "CelestialBody.h"

class Universe {
 public:
    explicit Universe(std::string filename);
        // friend std::istream &std::operator>>(std::istream
        // &input, const CelestialBody &c);
 private:
    int num;
    double radius;
};

#endif // NOLINT