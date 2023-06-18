// Copyright [2022] <Hrithik Verma Surapuraju>
#ifndef FIBLFSR // NOLINT
#define FIBLFSR // NOLINT

#include <iostream>
#include <string>
#include <bitset>

class FibLFSR{
 public:
        explicit FibLFSR(std::string seed);
        int step();
        int generate(int k);

 private:
        std::bitset<16> fib;
};

#endif // NOLINT
