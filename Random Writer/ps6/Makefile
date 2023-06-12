all: TextWriter test

TextWriter: TextWriter.cpp RandWriter.cpp
	g++ -o TextWriter TextWriter.cpp RandWriter.cpp

test: obj.o
	g++ -o test test.o RandWriter.o /usr/local/lib/libboost_unit_test_framework.a
	rm -f *.o

obj.o: test.cpp RandWriter.cpp
	g++ -c test.cpp RandWriter.cpp -DDEBUG=1

clean:
	rm -f TextWriter test *.o

