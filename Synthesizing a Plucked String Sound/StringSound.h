// Copyright 2022 Hrithik Verma Surapuraju
#ifndef STRINGSOUND // NOLINT
#define STRINGSOUND // NOLINT
#include <iostream>
#include <vector>
#include <SFML/Window.hpp>
#include "CircularBuffer.h"

class StringSound {
 public:
    explicit StringSound(double frequency);
    explicit StringSound(std::vector<sf::Int16> init);
    StringSound(const StringSound &obj);
    ~StringSound();
    void pluck();
    void tic();
    sf::Int16 sample();
    int ttime();

 private:
    CircularBuffer* _cb;
    int _time;
};

#endif // NOLINT
