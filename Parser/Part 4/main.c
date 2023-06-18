#include <stdio.h>
#include "decl.h"
#include "expr.h"
#include "param_list.h"
#include "stmt.h"
#include "type.h"

extern int yyparse();
extern FILE *yyin;
extern struct decl* parser_result;

int main(int argc, char* argv[])
{
	yyin = fopen(argv[1],"r");
	if(!yyin) {
		printf("could not open program.c!\n");
		return 1;
	}

	if(yyparse() == 0) {
		printf("Not possible.....\n");
		return 0;
	} else {
		decl_resolve(parser_result);
		decl_typecheck(parser_result);
		return 1;
	}
}
