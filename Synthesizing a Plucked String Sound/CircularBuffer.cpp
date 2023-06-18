// Copyright 2022 Hrithik Verma Surapuraju
#include "CircularBuffer.h"
#ifndef DEBUG
#define DEBUG   0
#endif

CircularBuffer::CircularBuffer(int capacity): _capacity(capacity) {
    try {
        if (capacity < 1) {
            throw std::invalid_argument("Capacity must be greater than zero.");
        }
        _capacity = capacity;
        _buffer = new int16_t[capacity];
        _first = 0;
        _last = 0;
        _full = false;
        _size = 0;
    } catch (std::invalid_argument& e) {
        std::cerr << e.what() << std::endl;
        _buffer = nullptr;
        if (DEBUG) throw std::invalid_argument("");
    }
}

CircularBuffer::~CircularBuffer() {
    if (_buffer != nullptr) {
        delete _buffer;
    }
}

int CircularBuffer::size() {
    return _size;
}

int CircularBuffer::getCapacity() {
    return _capacity;
}

bool CircularBuffer::isEmpty() {
    return (!_full && (_first == _last));
}

bool CircularBuffer::isFull() {
    return _full;
}

void CircularBuffer::enqueue(int16_t x) {
    try {
        if (_full) {
            throw std::runtime_error("enqueue: can't enqueue to a full ring.");
        }
        _buffer[_last++] = x;
        _last %= _capacity;
        _size++;
        if (!_full && (_first == _last)) _full = true;
    } catch (std::runtime_error& e) {
        std::cerr << e.what() << std::endl;
        if (DEBUG) throw std::runtime_error("");
    }
}

int16_t CircularBuffer::dequeue() {
    try {
        if (!_full && (_first == _last)) {
            throw std::runtime_error("dequeue: can't dequeue an empty ring.");
        }
        if (_full) _full = false;
        int16_t value = _buffer[_first++];
        _first %= _capacity;
        _size--;
        return value;
    } catch (std::runtime_error& e) {
        std::cerr << e.what() << std::endl;
        if (DEBUG) throw std::runtime_error("");
    }
}

int16_t CircularBuffer::peek() {
    try {
        if (!_full && (_first == _last)) {
            throw std::runtime_error("peek: can't dequeue an empty ring.");
        }
        int16_t value = _buffer[_first];
        return value;
    } catch (std::runtime_error& e) {
        std::cerr << e.what() << std::endl;
        if (DEBUG) throw std::runtime_error("");
    }
}

void CircularBuffer::empty() {
    _full = false;
    _first = _last = 0;
}

