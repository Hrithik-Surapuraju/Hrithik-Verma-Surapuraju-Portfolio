#include <stdio.h>

extern int yyparse();
extern FILE *yyin;

int main(int argc, char* argv[])
{
	yyin = fopen(argv[1],"r");
	if(!yyin) {
			printf("could not open program.c!\n");
			return 1;
	}

	if(yyparse() == 0) {
		printf("Parse successful!\n");
		return 0;
	} else {
		printf("Parse failed.\n");
		return 1;
	}
}
