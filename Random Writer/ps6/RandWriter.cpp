// Copyright 2022 Xxxxx
#include <iostream>
#include <algorithm>
#include <vector>
#include "RandWriter.h"

#ifndef DEBUG
#define DEBUG  0
#endif

unsigned seed;

RandWriter::RandWriter(std::string text, int k): _k(k) {
    try {
        if (text.length() < k) {
            throw std::invalid_argument("text length must be greater" \
                                        " or equal to k");
        }
    } catch (std::invalid_argument& e) {
        std::cerr << e.what() << std::endl;
        if (DEBUG) throw std::invalid_argument("");
        return;
    }

    // Create active alphabet list found in input text
    for_each(text.begin(), text.end(), [&](char c) {
        if (_alphabet.find(c) == std::string::npos)
            _alphabet.push_back(c);
    });
    sort(_alphabet.begin(), _alphabet.end());

    seed = unsigned(time(0));
    // _keyfreq is a map of <string, vector<int>>, where the key is k_gram
    // and vector<int> is 129 frequencies. Index 0 to 127 are used to keep
    // the frequency of char(index) that following the k_gram,
    // and index 128 (the last index) is used to keep the frequency of
    // k_gram in the whole text

    int textLength = text.length();
    if (k > 0) text = text + text.substr(0, k-1);   // circular effect

    auto freqCounting = [&](int k){
        for (int idx = 0; idx < textLength; idx++) {
            std::string key = text.substr(idx, k);
            if (_keyfreq.find(key) == _keyfreq.end()) {
                _keyfreq[key].assign(129, 0);
            }
            _keyfreq[key][static_cast<int>(text[idx+k])]++;
            _keyfreq[key][128]++;
        }
    };

    freqCounting(k);
    setKgram();
}

RandWriter::~RandWriter() {
}

int RandWriter::order_k() {
    return _k;
}

int RandWriter::freq(std::string k_gram) {
    try {
        if (k_gram.length() != order_k())
            throw std::runtime_error("k_gram length not equal to order k");

        // if k_gram is not found, return 0
        if (_keyfreq.find(k_gram) == _keyfreq.end()) {
            return 0;
        }
    } catch (std::runtime_error& e) {
        std::cerr << e.what() << std::endl;
        if (DEBUG) throw std::runtime_error("");
    }
    return _keyfreq[k_gram][128];
}

int RandWriter::freq(std::string k_gram, char c) {
    try {
        if (k_gram.length() != order_k())
            throw std::runtime_error("k_gram length not equal to order k");

        // if k_gram is not found, return 0
        if (_keyfreq.find(k_gram) == _keyfreq.end()) return 0;
    } catch (std::runtime_error& e) {
        std::cerr << e.what() << std::endl;
        if (DEBUG) throw std::runtime_error("");
    }
    return _keyfreq[k_gram][static_cast<int>(c)];
}

char RandWriter::k_Rand(std::string k_gram) {
    int knum = freq(k_gram);
    if (knum == 0) throw std::runtime_error("knum == 0");
    int randomNum = rand_r(&seed) % _keyfreq[k_gram][128];
    for (auto& c : _alphabet) {
        if (randomNum < _keyfreq[k_gram][static_cast<int>(c)]) return c;
        randomNum -= _keyfreq[k_gram][static_cast<int>(c)];
    }
}

std::string RandWriter::generate(std::string k_gram, int L) {
    std::string result;
    try {
        if (L < 1 || L < k_gram.length())
            throw std::invalid_argument("L must be greater than k_gram");
    } catch (std::invalid_argument& e) {
        std::cerr << e.what() << std::endl;
        if (DEBUG) throw std::invalid_argument("");
        return result;
    }
    result = k_gram;
    std::string kg = k_gram;
    char c;
    while (result.length() < L) {
        try {
            c = k_Rand(kg);
        } catch (std::runtime_error& e) {
            continue;
        }
        if (kg.length()) kg = kg.substr(1, _k - 1) + c;
        result += c;
    }
    return result;
}

std::string RandWriter::getAlphabet() {
    return _alphabet;
}

void RandWriter::setKgram() {
    int n = _keyfreq.size();
    seed = unsigned (time(0));
    std::map<std::string, std::vector<int>>::iterator it = _keyfreq.begin();
    int rr = rand_r(&seed);
    std::advance(it, rand_r(&seed) % n);
    _k_gram = (*it).first;
}

std::string RandWriter::getKgram() {
    return _k_gram;
}


std::ostream& operator <<(std::ostream& os, RandWriter& R) {
    std::string alpha = R.getAlphabet();
    os << "Order: " << R.order_k() << std::endl;
    os << "Alphabet: " << alpha << std::endl;
    std::string k_gram = R.getKgram();
    os << "k_gram frequency: " << std::endl;
    os << k_gram << " " << R.freq(k_gram) << std::endl;
    os << "k+1_gram frequency: " << std::endl;
    int f;
    for (char c : alpha) {
        if ((f = R.freq(k_gram, c)) > 0)
            os << c << " " << f << std::endl;
    }
    return os;
}

