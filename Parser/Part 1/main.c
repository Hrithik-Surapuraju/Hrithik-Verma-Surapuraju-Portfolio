#include "token.h"
#include <stdio.h>

extern FILE *yyin;
extern int yylex();
extern char *yytext;

int main(int argc, char* argv[])
{
	char token_str[50][20] = {  "TOKEN_EOF",
								"TOKEN_NEWLINE",
								"TOKEN_ADD",
								"TOKEN_CCOMMENT",
								"TOKEN_CPPCOMMENT",
								"TOKEN_LPAREN",
								"TOKEN_RPAREN",
								"TOKEN_LSQBRAC",
								"TOKEN_RSQBRAC",
								"TOKEN_INCREMENT",
								"TOKEN_DECREMENT",
								"TOKEN_MINUS",
								"TOKEN_LNOT",
								"TOKEN_MULT",
								"TOKEN_DIV",
								"TOKEN_MOD",
								"TOKEN_LESS",
								"TOKEN_LESSEQ",
								"TOKEN_GREAT",
								"TOKEN_GREATEQ",
								"TOKEN_EQUAL",
								"TOKEN_NOTEQ",
								"TOKEN_LAND",
								"TOKEN_LOR",
								"TOKEN_ASSIGN",
								"TOKEN_WHILE",
								"TOKEN_IDENT",
								"TOKEN_NUMBER",
								"TOKEN_ARRAY",
								"TOKEN_AUTO",
								"TOKEN_BOOLEAN",
								"TOKEN_CHAR",
								"TOKEN_ELSE",
								"TOKEN_FALSE",
								"TOKEN_FOR",
								"TOKEN_FUNCTION",
								"TOKEN_IF",
								"TOKEN_INT",
								"TOKEN_PRINT",
								"TOKEN_RETURN",
								"TOKEN_STRING",
								"TOKEN_TRUE",
								"TOKEN_VOID",
								"TOKEN_COLON",
								"TOKEN_SEMICOLON",
								"TOKEN_COMMA",
								"TOKEN_LBRACE",
								"TOKEN_RBRACE",
								"TOKEN_STRVAL",
								"TOKEN_ERROR" };


	yyin = fopen(argv[1],"r");
	if(!yyin) {
		printf("could not open program.c!\n");
		return 1;
	}

	int line_counter = 1;

	while(1) {
		token_t t = yylex();
		if(t == TOKEN_EOF) break;

		if (t == TOKEN_SEMICOLON) {
			printf("Line %d		Token: %s		Value: %s\n", line_counter, token_str[t], yytext);
			line_counter++;
			continue;
		}
		if (t == TOKEN_ERROR) {
			printf("Error at line %d, couldn't recognize: %s\n", line_counter, yytext);
			continue;
		}

		printf("Line %d		Token: %s		Value: %s\n", line_counter, token_str[t], yytext);
	}
}
