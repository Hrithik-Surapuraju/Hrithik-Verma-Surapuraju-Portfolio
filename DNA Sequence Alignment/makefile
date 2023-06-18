CC = g++
EXE = EDistance
FLAGS = -Wall -Werror -pedantic -g
DEPS =
OBJS = main.o
LIBS = -lsfml-window -lsfml-system -lsfml-graphics
all: $(EXE)

$(EXE): $(OBJS) $(LIBS)    
	$(CC) $(FLAGS) -o $@  $^
%.o : %.cpp
	$(CC) -c $^
clean:
	rm $(EXE) $(OBJS)
