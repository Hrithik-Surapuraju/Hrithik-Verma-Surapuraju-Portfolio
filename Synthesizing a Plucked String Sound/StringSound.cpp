// Copyright 2022 Hrithik Verma Surapuraju
#include <unistd.h>
#include <cmath>
#include "StringSound.h"
#ifndef DEBUG
#define DEBUG   0
#endif

StringSound::StringSound(double frequency) {
    try {
        if (frequency < 1) {
            throw std::invalid_argument("StringSound: Invalid frequency");
        }
        int N = ceil(44100 / frequency);
        _cb = new CircularBuffer(N);
    } catch (std::invalid_argument& e) {
        std::cout << e.what() << std::endl;
        if (DEBUG) throw std::invalid_argument("");
    }
}

StringSound::StringSound(std::vector<sf::Int16> init) {
    auto vinit = [](std::vector<sf::Int16> init) {
        CircularBuffer *cb = new CircularBuffer(init.size());
        for (int i=0; i < init.size(); i++) {
            cb->enqueue(init[i]);
        }
    return cb;
    };
    _cb = vinit(init);
}

StringSound::StringSound(const StringSound &obj) {
    *(this) = obj;
}

StringSound::~StringSound() {
    if (_cb != nullptr)
        delete _cb;
}

void StringSound::pluck() {
    _cb->empty();
    unsigned int seed = static_cast<int>(time(0));  // srand(int(time(0)));
    for (int i = 0; i < _cb->getCapacity(); i++) {
        _cb->enqueue(rand_r(&seed)%65536 - 32768);
    }
    _time = 0;
}

void StringSound::tic() {
    sf::Int16 curvalue = _cb->dequeue();   // Get the first value
    sf::Int16 nextvalue = _cb->peek();     // Get the second value

    // Guitar used 50% 50% mix
    sf::Int16 calvalue = 0.996 * (0.5 * curvalue + 0.5 * nextvalue);

    // insert to the circular buffer
    // Version 1: Insert 100 out of 100
    // comment below line to change to Extra Credit
    _cb->enqueue(calvalue);

    // Extra credit:
    // uncomment below lines

    /*
    if (_time % 100) {
        _cb->enqueue(calvalue);
    } else if (_cb->size() < 5) {
        _cb->enqueue(calvalue);
    }
    */
    _time++;
    _time %= 1000000;
}

// Get the first available sample
sf::Int16 StringSound::sample() {
    return _cb->peek();
}

// Get time counter
int StringSound::ttime() {
    return _time;
}

