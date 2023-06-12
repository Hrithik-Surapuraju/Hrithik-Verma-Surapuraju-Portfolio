CC = g++
EXE = NBody
FLAGS = -Wall -Werror -pedantic -g
DEPS =
OBJS = NBody.o
LIBS = -lsfml-window -lsfml-system -lsfml-graphics -lsfml-audio
all: $(EXE)

$(EXE): $(OBJS) $(LIBS)    
	$(CC) $(FLAGS) -o $@  $^
%.o : %.cpp
	$(CC) -c $^
clean:
	rm $(EXE) $(OBJS)