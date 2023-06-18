// Copyright 2022 Hrithik Verma Surapuraju
#ifndef CIRCULARBUFFER // NOLINT
#define CIRCULARBUFFER // NOLINT
#include <stdint.h>
#include <iostream>
#include <stdexcept>

class CircularBuffer {
 public:
    explicit CircularBuffer(int capacity);
    ~CircularBuffer();
    int size();
    bool isEmpty();
    bool isFull();
    void enqueue(int16_t x);
    int16_t dequeue();
    int16_t peek();
    void empty();
    int getCapacity();

 private:
    int16_t *_buffer;
    int     _first;
    int     _last;
    int     _size;
    int     _capacity;
    bool    _full;
};

#endif  // NOLINT