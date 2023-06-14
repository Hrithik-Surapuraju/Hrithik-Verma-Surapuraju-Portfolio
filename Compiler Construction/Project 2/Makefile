parse: main.o scanner.o parser.o 
	gcc main.o scanner.o parser.o -o parse -lm

%.o: %.c *.h
	gcc -Wall -c $< -o $@

scanner.c: scanner.flex parser.h
	flex -oscanner.c scanner.flex

parser.c parser.h: bminor-parser.bison
	bison --defines=parser.h --output=parser.c -v bminor-parser.bison

clean:
	rm -f parser.* parser.output scanner.c *.o parse

