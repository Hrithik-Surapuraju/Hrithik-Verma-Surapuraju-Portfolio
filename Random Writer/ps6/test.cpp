// Copyright 2022 Xxxx
#define BOOST_TEST_MODULE RandWriter testcases
#include <boost/test/unit_test.hpp>
#include "RandWriter.h"


BOOST_AUTO_TEST_CASE(randWriter_test) {
    // Test invalid argument in constructor, k > text length
    std::string text = "abcd";
    BOOST_REQUIRE_THROW(RandWriter rw(text, 5), std::invalid_argument);

    // Check methods
    text = "this is text for testing, and this is short text";
    RandWriter randWriter(text, 4);

    BOOST_REQUIRE(randWriter.order_k() == 4);
    BOOST_REQUIRE(randWriter.freq("text") == 2);
    BOOST_REQUIRE(randWriter.freq("text", ' ') == 1);

    BOOST_REQUIRE(randWriter.k_Rand("test") == 'i');
    BOOST_REQUIRE(randWriter.generate("test", 7) == "testing");

    // Check exception in normal condition
    BOOST_REQUIRE_NO_THROW(randWriter.freq("shor"));
    BOOST_REQUIRE_THROW(randWriter.freq("sho"), std::runtime_error);
}
