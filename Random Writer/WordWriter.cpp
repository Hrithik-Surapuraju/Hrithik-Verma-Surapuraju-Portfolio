// Copyright 2022 Hrithik Verma Surapuraju
#include <iostream>
#include "WordWriter.h"

#ifndef DEBUG
#define DEBUG  0
#endif

unsigned seed;

WordWriter::WordWriter(std::string text, int k): _k(k) {
    try {
        if (text.length() == 0) {
            throw std::invalid_argument("text length must be greater" \
                                        " or equal to k");
        }
    } catch (std::invalid_argument& e) {
        std::cerr << e.what() << std::endl;
        if (DEBUG) throw std::invalid_argument("");
        return;
    }
    std::string w, key;
    int wc = 0, pos = 0, next;
    seed = unsigned(time(0));

    // _wordfreq is a map of <string, map<string, int>>, where the key is
    // k words, and mapped to another map, which is map of the next word
    // following the key and frequency of this word (
    // map[key][nextWord] -> frequency of nextWord following the key).
    // Frequency of the key itself is saved in map[key][""]
    auto buildKey = [&](int k) {
        next = text.find_first_not_of(32, 0);
        if (next == std::string::npos) return;
        while (wc < k) {
            pos = text.find_first_of(' ', next);
            w = text.substr(next, pos - next);
            key += w + " ";
            next = text.find_first_not_of(32, pos + 1);
            if (next == std::string::npos) return;
            wc++;
        }
    };

    if (k) buildKey(k);
    if (k > 0) key = key.substr(0, key.size()-1);
    while (true) {
        next = text.find_first_not_of(32, pos + 1);
        if (next == std::string::npos) break;
        pos = text.find_first_of(32, next);
        if (pos == std::string::npos) break;
        w = text.substr(next, pos - next);
        if (w.size() < 1) break;
        _wordfreq[key][""]++;
        _wordfreq[key][w]++;
        if (k > 1)
            key = key.substr(key.find_first_of(32) + 1) + " " + w;
        else if (k == 1)
            key = w;
    }
    setWord();
}

WordWriter::~WordWriter() {
}

int WordWriter::order_k() {
    return _k;
}

int WordWriter::freq(std::string word) {
    return _wordfreq[word][""];
}

int WordWriter::freq(std::string word1, std::string word2) {
    return _wordfreq[word1][word2];
}

std::string WordWriter::k_Rand(std::string word) {
    int randomNum = rand_r(&seed) % _wordfreq[word][""];
    std::map<std::string, int>::iterator it;
    for (it = _wordfreq[word].begin(); it != _wordfreq[word].end(); it++) {
        if (it->first != "") {
            if (randomNum < it->second)
                return it->first;
            randomNum -= it->second;
        }
    }
}

std::string WordWriter::generate(std::string word, int L) {
    std::string key = word, first;
    std::string output;
    int wcount = _k;
    output = word;
    while (wcount < L) {
        std::string w = k_Rand(key);
        output += " " + w;
        int next = key.find_first_of(32, 0);
        if (next == std::string::npos) next = key.length();
        if (_k > 2) {
            first = key.substr(next + 1);
            if (key.length()) key = first + " " + w;
        } else if (_k == 1) {
            key = w;
        }
        wcount++;
    }
    return output;
}

void WordWriter::setWord() {
    std::map<std::string, std::map<std::string, int>>::iterator it =
              _wordfreq.begin();
    std::advance(it, rand_r(&seed) % _wordfreq.size());
    _word_gram = it->first;
}

std::string WordWriter::getWord() {
    return _word_gram;
}

std::ostream& operator <<(std::ostream& os, WordWriter& W) {
    os << "Order: " << W.order_k() << std::endl;
    std::string w = W.getWord();
    os << "k_gram: " << w << std::endl;
    os << "k_gram frequency: " << W.freq(w) << std::endl;
    return os;
}

