// Copyright [2022] <Hrithik Verma Surapuraju>
#include <iostream>
#include <string>
#include "FibLFSR.h"

FibLFSR::FibLFSR(std::string seed ) {
        std::bitset<16> t(seed);
        fib = t;
}

int FibLFSR::step() {
        bool tap = fib[15] ^ fib[13] ^ fib[12] ^ fib[10];


        for (int i = 15; i > 0 ; i--) {
                fib[i] = fib[i-1];
        }
        fib[0] = tap;
        return tap;
}

int FibLFSR::generate(int k) {
        int i = 0;
        while (--k) {
                i = 2*i+step();
        }
        return i;
}

