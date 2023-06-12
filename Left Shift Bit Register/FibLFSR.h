#ifndef FIBLFSR
#define FIBLFSR

#include <iostream>
#include <string>
#include <bitset>

class FibLFSR
{
	public:
		FibLFSR(std::string seed);
		int step();
		int generate(int k);

	private:
		std::bitset<16> fib;
};

#endif
