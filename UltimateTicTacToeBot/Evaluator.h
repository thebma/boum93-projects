#ifndef EVALUATOR_H
#define EVALUATOR_H

#include "Common.h"
#include "Field.h"

int FieldEvaluationFunction(Field* field, FieldState perspective);
int HasWinner(Field* field);
FieldState GetWinner(Field* field);

#endif