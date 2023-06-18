pretty-print: main.o scanner.o parser.o decl.o stmt.o type.o expr.o param_list.o
	gcc main.o scanner.o parser.o decl.o stmt.o type.o expr.o param_list.o -o pretty-print -lm

%.o: %.c *.h
	gcc -Wall -c $< -o $@

scanner.c: scanner.flex parser.h
	flex -oscanner.c scanner.flex

parser.c parser.h: bminor-parser.bison
	bison --defines=parser.h --output=parser.c -v bminor-parser.bison

clean:
	rm -f parser.* parser.output scanner.c *.o pretty-print